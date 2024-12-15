<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimesStampTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::table('comments')->delete();
    }

    public function testInsert()
    {
        $comment = new Comment();
        $comment->username = "Erwin2231";
        $comment->email = "pBw0M@example.com";
        $comment->comment = "Seharusnya bisa lebih baik dari pada ini!";
        $comment->save();

        self::assertNotNull($comment->id);
        
    }

    public function testUpdate()
    {
        $this->testInsert();
        $newComment = Comment::find(1);

        $newComment->comment = "Udah baik ko:)";
        $result = $newComment->update();
        Log::info(json_encode($result));
        self::assertEquals(true, $result);

    }
}
