<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'description' => $this->description,
            'type' => $this->type,
            'langue' => $this->langue,
            'editeur' => $this->editeur,
            'categorie' => $this->categorie,
            'prix' => $this->prix,
            'auteur' => $this->auteur,
            'annee' => $this->annee,
            'cover' => asset('covers/' . $this->cover),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
