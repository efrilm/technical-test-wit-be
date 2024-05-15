<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fotoUrl = $this->foto;
        if (Str::contains($fotoUrl, 'http')) {
            $foto = $this->foto;
        } else {
            $foto = env('APP_URL') . Storage::url(Employee::PATH . '/' . $this->foto);
        }

        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'nomor' => $this->nomor,
            'jabatan' => $this->jabatan,
            'departmen' => $this->departmen,
            'tanggal_masuk' => $this->tanggal_masuk,
            'foto' => $foto,
            'status' => $this->status,
        ];
    }
}
