<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Ambil data gallery dengan judul post slider
        $gallery = Post::where('title', 'Slider')->first()->galleries->where('status', 'aktif')->first();

        // Dapatkan data images dari hasil slider gallery
        $sliders = $gallery->images;

        // ambil data post dengan kategori galeri sekolah kecuali post dengan judul slider
        $post = Post::whereHas('category', function ($query){
            $query->where('title', 'Galeri Sekolah');
        })->where('title','!=', 'Slider')->get();

        // ambil post dengan kategori agenda sekolah
        $agendas = Post::whereHas('category', function ($query) {
            $query->where('title', 'Agenda Sekolah');
        })->get();

        // ambil data dengan kategori informasi terkini
        $information = Post::whereHas('category', function ($query) {
            $query->where('title', 'Informasi Terkini');
        })->first();

        // ambil data dengan kategori peta
        $map = Post::whereHas('category', function ($query) {
            $query->where('title', 'Peta');
        })->first();

        return view('welcome', [
            'sliders' => $sliders,
            'posts' => $post,
            'agendas' => $agendas,
            'information' => $information,
            'map' => $map,
        ]);
    }
}
