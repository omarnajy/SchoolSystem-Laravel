<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StudentsTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Jean Dupont',
                'jean.dupont@email.com',
                'motdepasse123',
                '2024001',
                '+212612345678',
                'male',
                '2000-01-15',
                '123 Rue de la Paix, Casablanca',
                '456 Avenue Hassan II, Rabat',
                'One',
                'mouad@gmail.com',
                'Monsieur Dupont'
            ],
            [
                'Marie Martin',
                'marie.martin@email.com',
                'password456',
                '2024002',
                '+212687654321',
                'female',
                '1999-06-22',
                '789 Boulevard Zerktouni, Casablanca',
                '321 Rue Allal Ben Abdellah, Rabat',
                'One',
                'mouad@gmail.com',
                'Madame Martin'
            ],
            [
                'Ahmed Alami',
                'ahmed.alami@email.com',
                'password789',
                '2024003',
                '+212698765432',
                'male',
                '2001-03-10',
                '45 Rue Mohamed V, Rabat',
                '67 Avenue Hassan II, Casablanca',
                'One',
                'mouad@gmail.com',
                'Monsieur Alami'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'email', 
            'mot_de_passe',
            'numero_matricule',
            'telephone',
            'genre',
            'date_naissance',
            'adresse_actuelle',
            'adresse_permanente',
            'nom_classe',
            'email_parent',
            'nom_parent'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour les en-têtes
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F46E5'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // nom
            'B' => 25, // email
            'C' => 15, // mot_de_passe
            'D' => 15, // numero_matricule
            'E' => 15, // telephone
            'F' => 10, // genre
            'G' => 15, // date_naissance
            'H' => 30, // adresse_actuelle
            'I' => 30, // adresse_permanente
            'J' => 20, // nom_classe
            'K' => 25, // email_parent
            'L' => 20, // nom_parent
        ];
    }
}