<?php

namespace Database\Seeders;

use App\Models\Comment ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'content' => 'Il tecnico ha iniziato a verificare il problema.'
            ],
            [
                'ticket_id' => 1,
                'user_id' => 1,
                'content' => 'Ho aggiunto alcune note sul ticket.'
            ],
            [
                'ticket_id' => 2,
                'user_id' => 2,
                'content' => 'Controllato il sistema, tutto ok.'
            ],
            [
                'ticket_id' => 3,
                'user_id' => 1,
                'content' => 'Attendo ulteriori informazioni dal cliente.'
            ],
            [
                'ticket_id' => 3,
                'user_id' => 1,
                'content' => 'Aggiornamento: il problema è stato risolto.'
            ],
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'content' => 'Ticket in attesa di approvazione.'
            ],
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'content' => 'Verificato log e trovato errore.'
            ],
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'content' => 'Soluzione applicata correttamente.'
            ],
        ];

        foreach ($comments as $comment) {
            $newComment = new Comment(); 

            $newComment->ticket_id = $comment['ticket_id'];
            $newComment->user_id = $comment['user_id'];
            $newComment->content = $comment['content'];

            $newComment->save();
        }
    }
}
