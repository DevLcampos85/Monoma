<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $model = Candidato::class;

    protected $fillable = [
        'id',
        'name',
        'source',
        'owner',
        'created_by',
        'created_at',
    ];

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'source' => $this->faker->domainName(),
            'owner' => $this->faker->owner(),
            'created_by' => $this->faker->created_by(),
        ];
    }
}