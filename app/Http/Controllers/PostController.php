<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Précharger user, likes, comments et user de chaque commentaire
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('index', compact('posts'));
    }

    public function create()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'category' => 'nullable|string',
            'media' => 'nullable|array',
            'media.*' => 'file|max:10240', // 10 Mo max

        ]);
        // dd($request->file('media'));
        foreach ($request->file('media') as $index => $file) {
            dump("media[$index]", $file->getClientOriginalName(), $file->getMimeType());
        }
        // Création du post
        $post = Post::create([
            'user_id' => auth()->id,
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
        ]);

        // Gestion des fichiers image et vidéo
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'video/') ? 'video' : (str_starts_with($mime, 'image/') ? 'image' : null);

                if (!$type) {
                    continue; // Ignore les fichiers non pris en charge
                }

                $path = $file->store('posts', 'public');

                $post->media()->create([
                    'media_type' => $type,
                    'media_url' => Storage::url($path),
                ]);
            }
        }

        return redirect()->route('activity')->with('success', 'Post créé avec succès avec images et/ou vidéos !');
    }

    public function show(Post $post)
    {
        return $post->load(['user', 'comments.user', 'likes']);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,webp,mov,avi,tiff|max:204800',
        ]);

        // Mise à jour des champs du post
        $post->update([
            'title' => $validated['title'],
            'body'  => $validated['body'] ?? null,
        ]);

        // Suppression des médias sélectionnés
        if ($request->filled('delete_media')) {
            foreach ($request->delete_media as $mediaId) {
                $media = $post->media()->find($mediaId);
                if ($media) {
                    // Supprimer le fichier du storage
                    $path = str_replace('/storage/', '', $media->media_url);
                    Storage::disk('public')->delete($path);

                    // Supprimer de la BDD
                    $media->delete();
                }
            }
        }

        // Ajout de nouveaux médias uploadés
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $path = $file->store('posts', 'public');

                $post->media()->create([
                    'media_type' => $type,
                    'media_url'  => Storage::url($path),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Post mis à jour !');


    }

    public function destroy(Post $post)
    {
        // Supprimer les médias associés
        if($post->media){
            foreach($post->media as $media){
                $path = str_replace('/storage/', '', $media->media_url); // récupérer le chemin réel
                Storage::disk('public')->delete($path);
                $media->delete(); // supprime la ligne media en base
            }
        }

        $post->delete(); // Supprime le post en base

        return redirect()->back()->with('success', 'Post supprimé !');
    }

}