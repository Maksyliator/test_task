<?php

namespace App\Tests;

use App\Models\User;
use App\Models\Post;

class DBTest extends BaseTest
{
    public function testOne()
    {
        $user = new User();
        $user->email = "some-email@mail.com";
        $user->first_name = "SomeName";
        $user->last_name = "SomeLastName";
        $user->password = 'SomePassword';
        $user->save();

        $this->assertNotNull(User::findOne()->id);
        $this->assertTrue(User::findOne()->id === $user->id);

        $post = new Post();
        $post->title = "SomePostTitle";
        $post->body = "SomePostBody";
        $post->creator_id = $user->id;
        $post->save();

        $this->assertNotNull(Post::findOne()->id);
        $this->assertTrue(Post::findOne()->id === $post->id);
        $this->assertTrue(Post::findOne()->creator_id === $user->id);
    }
}
