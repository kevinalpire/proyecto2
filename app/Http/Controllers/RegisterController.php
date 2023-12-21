<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $registros = Register::where('mensaje_enviado', '!=', 'null')->get();
        $productos = [];
        $fechas = [];

        for ($i = 0; $i < 10; $i++) {
            $fecha = now()->subDays($i)->format('d/m/Y');
            $fechas[$fecha] = [];
        }
        foreach ($registros as $key => $value) {
            // Productos
            $partes = explode(',', strtolower($value->mensaje_enviado));
            if (count($partes) < 2) {
                continue;
            }
            if (substr($partes[1], -1) == '.') {
                $producto = substr($partes[1], 0, -1);
            } else {
                $producto = $partes[1];
            }

            // if (!array_key_exists($producto, $productos)) {
            //     $productos[$producto] = 1;
            // } else {
            //     $productos[$producto]++;
            // }
            if ($producto != ' sin producto') {
                if (!array_key_exists($producto, $productos)) {
                    $productos[$producto] = 1;
                } else {
                    $productos[$producto]++;
                }
            }

            // Fechas
            $calificacion = $partes[0];

            $fechas[array_rand($fechas)][] = $calificacion;
        }

        foreach ($fechas as $key => $value) {
            $suma = array_sum($value);
            $cantidad = count($value);
            $promedio = round($suma / $cantidad, 2);
            $fechas[$key] = $promedio;
        }
        return view('welcome', compact('productos', 'fechas'));
    }
}
