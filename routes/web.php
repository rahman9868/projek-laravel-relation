<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\User;
use App\Profile;
use App\Post;
use App\Category;
use App\Role;
use App\Portfolio;
use App\Tag;

Route::get('/create_user', function () {
    $user = User::create([
        'name' => 'alunch',
        'email' => 'alunch@outlook.com',
        'password' => bcrypt('password')
    ]);
    return $user;
});


Route::get('/create_profile', function () {
    // $profile = Profile::create([
    //     'user_id' => 2,
    //     'phone' => '010207045843',
    //     'address' => 'Jl. Sawahan, No.79'
    // ]);
    
    $user = User::find(1);
    
    $user->profile()->create([
        'phone' =>'12125986476',
        'address' => 'Jl. Andalas, No.96 menggunakan method create_profile'
    ]);
    return $user;
});


Route::get('/create_user_profile', function () {
    $user = User::find(2);

    $profile = new Profile([
        'phone' => "0868429423",
        'address' => 'Jl.Raya, N0 875'
    ]);

    $user->profile()->save($profile);
    return $user;
});

Route::get('/read_user', function () {
    $user = User::find(1);

    $data = [
        "name" => $user->name,
        "phone" => $user->profile->phone,
        "address" => $user->profile->address
    ];
    return $data;

});

Route::get('/read_profile', function () {
    $profile = Profile::where('phone','010207045843')->first();

    //return $profile->user->name;
    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->phone,
        'address' => $profile->address
    ];
    return $data;
});

Route::get('/update_profile', function () {
    $user = User::find(2);

    $data = [
        'phone' => 65748,
        'address' => 'Jl.Baru update'
    ];
    $user->profile()->update($data);
    return $user;
});

Route::get('/delete_profile', function () {
    $user = User::find(1);
    $user->profile()->delete();

    return $user;
});

Route::get('/create_post', function () {
    // $user = User::create([
    //     'name' => 'alunch',
    //     'email' => 'alunch@mail.com',
    //     'password' => bcrypt('password')
    // ]);

    $user = User::findOrFail(2);

    $user->posts()->create([
        'title' => 'Isi Title Post Baru Milik Member 1',
        'body' => 'Hello World! Ini isi dari body tabel post baru milik Member 1'
    ]);
    
    return 'Success';
});

Route::get('/read_posts', function () {
    $user = User::find(7);

    $posts = $user->posts()->get();

    foreach ($posts as $post){
        $data[] = [
            'name' => $post->user->name,
            'post_id' => $post->id,
            'title' => $post->title,
            'body' => $post->body
        ];
    }    
    return $data;
});

Route::get('/update_post', function () {
    $user = User::findOrFail(7);

    $user->posts()->update([
        'title' => 'Isian Title Post Update Semua',
        'body' => 'ini isian Body Post yang sudah di update Semua'
    ]);

    return 'Success';
});

Route::get('/delete_post', function () {
    $user = User::find(7);

    $user->posts()->whereId(8)->delete();

    return 'Success'; 
});

Route::get('/create_categories', function () {
    // $post = Post::findOrFail(1);

    // $post->categories()->create([
    //     'slug' => str_slug('PHP','-'),
    //     'category' => 'PHP'
    // ]);

    // return 'Success';

    $user = User::create([
        'name'=> 'chairul',
        'email' => 'chairul@mail.com',
        'password' => bcrypt('password')
    ]);

    $user->posts()->create([
        'title' => 'new title',
        'body' => 'new body content'
    ])->categories()->create([
        'slug' => str_slug('New Category','-'),
        'category' => 'New Category'
    ]);

    return 'Success';
});

Route::get('/read_category', function () {
    $post = Post::find(2);

    $categories = $post->categories;
    foreach ($categories as $category){
        echo $category ->slug .'</br>';
    }

    // $category = Category::find(3);

    // $posts = $category->posts;

    // foreach ($posts as $post){
    //     echo $post->title . '</br>';
    // }

});

Route::get('/attach', function () {
    $post = Post::find(3);
    $post->categories()->attach([1,2,3]);

    Return 'Success';

});

Route::get('/detach', function () {
    $post = Post::find(2);
    $post->categories()->detach();

    return 'Success';
});

Route::get('/sync', function () {
    $post = Post::find(3);
    $post->categories()->sync([1,3]);

    return 'Success';
});

Route::get('/role/posts', function () {
    $role = Role::find(2);
    return $role->posts;

});

Route::get('/comment/create', function () {
    // $post = Post::find(1);
    // $post->comments()->create([
    //     'user_id' => 2, 'content' => 'Balasan dari respon user id 1'
    // ]);

    $post = Portfolio::find(1);
    $post->comments()->create([
        'user_id' => 2, 'content' => 'Balasan dari portfolio respon user id 1'
    ]);

    Return 'Success';
});


Route::get('/comment/read', function () {
    // $post = Post::findOrFail(1);
    // $comments = $post->comments;
    
    // foreach ($comments as $comment){
    //     echo $comment->user->name . ' - ' . $comment->content . '('. $comment->commentable->title .')<br>';
    // }

    $portfolio = Portfolio::findOrFail(1);
    $comments = $portfolio->comments;
    
    foreach ($comments as $comment){ 
        echo $comment->user->name . ' - ' . $comment->content . '('. $comment->commentable->title .')<br>';
    }
});

Route::get('/comment/update', function () {
    // $post = Post::find(1);
    
    // $comment = $post->comments()->where('id', 1)->first();
    // $comment->update([
    //     'content' => 'Komentarnya telah disunting'
    // ]);

    $portfolio = Portfolio::find(1);
    
    $comment = $portfolio->comments()->where('id', 3)->first();
    $comment->update([
        'content' => 'Komentarnya telah disunting dibagian portfolio'
    ]);
    return 'Success';
});


Route::get('/comment/delete', function () {
    // $post = Post::find(1);
    // $post->comments()->where('id',2)->delete();

    $portfolio = Portfolio::find(1);
    $portfolio->comments()->where('id',2)->delete();

    return 'Success';
});

Route::get('/tag/read', function () {
    // $post = Post::find(1);

    // foreach ($post->tags as $tag){
    //     echo $tag->name . '<br>';
    // }

    $portfolio = Portfolio::find(1);

    foreach ($portfolio->tags as $tag){
        echo $tag->name . '<br>';
    }
    
});

Route::get('/tag/attach', function () {
    $post = Post::find(1);
    $post->tags()->attach([5,7,8]);

    // $portfolio = Portfolio::find(1);
    // $portfolio->tags()->attach([4,6]);

    return 'Success';

});

Route::get('/tag/detach', function () {
    // $post = Post::find(1);
    // $post->tags()->detach([1,3]);

    $portfolio = Portfolio::find(1);
    $portfolio->tags()->detach([2,4]);

    return 'Success';
});

Route::get('/tag/sync', function () {
    $post = Post::find(1);

    $post->tags()->sync([8]);
    
});