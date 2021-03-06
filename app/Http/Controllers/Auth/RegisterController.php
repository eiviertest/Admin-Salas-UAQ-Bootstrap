<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Persona;
use App\Models\User;
use App\Models\Area;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nomPer' => ['required','string','max:200'],
            'apePatPer' => ['required','string','max:200'],
            'telPer' => ['required','int','digits_between:7,10'],
            'idArea' => ['required','string','max:200', 'min:10'],
            'tipoTel' => ['required', 'int', 'digits:1', 'min:1', 'max:2'],
            'extension' => 'exclude_if:tipoTel,1|int|required|digits_between:3,5'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ])->assignRole('User');

            $nomArea = $data['idArea'];
            $dataArea = $this->getIdArea($nomArea);
            if(empty($idArea)) {
                $area = new Area();
                $area->nomArea = $nomArea;
                $area->save();
                $dataArea = $area;
            }
            $persona = new Persona();
            $persona->nomPer = $data['nomPer'];
            $persona->apePatPer = $data['apePatPer'];
            $persona->apeMatPer = $data['apeMatPer'];
            $persona->telPer = $data['telPer'];
            $persona->tipoTel = $data['tipoTel'];
            $persona->extension = $data['extension'];
            $persona->idArea = $dataArea->idArea;
            $persona->idUsr = $user->id;
            $persona->save();
            return $user;
        }catch(exception $e) {
            return $e->getMessage();
        }
    }
}
