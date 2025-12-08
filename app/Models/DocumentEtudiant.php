<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentEtudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_etudiant',
        'type_document',
        'nom_fichier',
        'chemin_fichier',
        'date_upload',
    ];

    public const TYPE_BULLETIN = 'Bulletin';
    public const TYPE_RELEVE_NOTES = 'Relevé de notes';
    public const TYPE_CERTIFICAT_SCOLARITE = 'Certificat de scolarité';
    public const TYPE_CARTE_IDENTITE = 'Carte d\'identité';
    public const TYPE_PHOTO = 'Photo';
    public const TYPE_ATTESTATION_BAC = 'Attestation BAC';

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }
}
