<?php
namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        return response()->json(SocialMedia::all());
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:social_media']);
        $media = SocialMedia::create($request->only('name'));
        return response()->json($media, 201);
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {
        $request->validate(['name' => 'required|unique:social_media,name,' . $socialMedia->id]);
        $socialMedia->update($request->only('name'));
        return response()->json($socialMedia);
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
