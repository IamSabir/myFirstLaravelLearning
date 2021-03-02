<?php

use PhpParser\Builder\Namespace_;

use App\Models\PostModel;
use App\Models\Flight;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Country;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Tag;
use App\Models\Tagable;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// // Route::get('/', [PostsController::class, 'show']);

// // Route::get('posts/{id}', [PostsController::class, 'show']);
// Route::get('posts/{id}', 'App\Http\Controllers\PostsController@show');


// Database Raw Query

// Route::get('/insert', function() {
//     $t = time();
//     $current_timestamp = date('y-m-d-h-m-s', $t);
//     echo $current_timestamp;
//     $created_at = $current_timestamp;
//     $updated_at = $created_at;
//     DB::insert('INSERT INTO posts(post_title, body, created_at, updated_at) values(?, ?, ?, ?)', ['Php Heading 3', 'Php Body 3', $created_at, $updated_at]);
// });


// Route::get('/read', function() {
//     $results = DB::select('SELECT * FROM posts where id=?', [2]);
//      print_r($results);
//     foreach($results as $result) {
//         return $result->post_title;
//         return $result->body;
//     }
// });


// Route::get('/update', function() {

//     $updated = DB::update('UPDATE posts SET post_title = "The Updated Title" WHERE id = ? ', [2]);

//     $results = DB::select('SELECT * FROM posts WHERE id=?', [2]);
//     // return $updated;

//     foreach($results as $result) {
//         echo 'The Updated Title is : ', $result->post_title, ' and the affected row is ', $result->id;
//     }
// });



// Route::get('/delete', function() {
//     $deleted = DB::delete('DELETE FROM posts where id=?', [1]);
//     echo 'Row Deleted';
// });


/*
------------------------------------------------------------------------
Eloquent ORM (Objject Relation Model)
------------------------------------------------------------------------

*/

//READ

// Route::get('/find', function() {

//     $posts = PostModel::all();

//     foreach($posts as $post) {
//         return $post->post_title;
//     }

// });


//FIND

// Route::get('/find', function() {

//     $posts = PostModel::find(2);
//     return $posts->post_title;
//     // foreach($posts as $post) {
//     //     return $post->post_title;
//     // }

// });

//FIND BY ID IN DESC ORDER
// Route::get('/findwhere', function() {
//     $posts = PostModel::where('id', 3)->orderBy('id', 'desc')->take(2)->get();
//     return $posts;
// });

// //FIND OR FAIL

// Route::get('/findmore', function() {
//     $posts = PostModel::findOrFail(2);
//     return $posts;
// });


//FIND COUNT

// Route::get('/findcount', function () {
//     $posts = PostModel::where('posts', '<', 50)->firstorfail();
// });


//Insert Data using Eloquent

Route::get('/basicinsert', function () {
    $post = new PostModel;

    $post->post_title = 'PHsynb esasa w Title';
    $post->user_id = 2;
    $post->body = "ds dsa ew gjhaf Body";
    $post->save();
});

//Update Data USing ELoquent

Route::get('/basicupdate', function () {
    // $post = new PostModel;

    $post = PostModel::find(4);

    $post->post_title = 'Title Update';
    $post->body = "Mind Body";
    $post->update();
});

Route::get('/flightinsert', function () {

    $flight = new Flight;

    $flight->flight_name = "Indian Airways";
    $flight->flight_number = 2;
    $flight->pilot_name = "Selim Ali";
    $flight->save();
});

Route::get('/flightupdate', function () {
    $flight = Flight::find(1);
    $flight->flight_name = "Indian Airways";
    $flight->update();
});

Route::get('/flights', function () {
    $flights =  Flight::all();

    foreach ($flights as $flight) {
        echo $flight->pilot_name, ' was flying ', $flight->flight_name, '<br>';
    }
});


Route::get('/create', function () {
    Flight::create([

        'flight_name' => 'The New Imndia\'s',
        'flight_number' => 45646,
        'pilot_name' => 'Mahira Ahmed',
        // 'is_admin' =>


    ]);
});

Route::get('/delete_flight', function () {

    //Using Delete Method
    // $flight = Flight::find(3);
    // $flight->delete();
    //Using Destroy Method

    //  $flight->destroy(3);

    // To Delete Mutiple records

    Flight::destroy(2);
});

Route::get('/soft_delete', function () {
    Flight::find(5)->delete();
});

Route::get('/retrieve_data', function () {
    // $flight = Flight::find(5);
    // return $flight;
    // $flight = Flight::withTrashed()->where('id', 5)->get();
    // return $flight;

    $flight = Flight::withTrashed()->where('is_admin', 0)->get();

    return $flight;
});

Route::get('/restore_deleted_data', function () {
    $flight = Flight::withTrashed()->where('is_admin', 0)->restore();
    return $flight;
});

Route::get('delete_permanantly', function () {
    $flight = Flight::onlyTrashed()->forceDelete();
});

Route::get('/create_user', function () {
    $time = time();
    $email_verified_at = date('y-m-d-h-m-s', $time);
    $user = new User;

    $user->name = 'Sabir Ali';
    $user->email = 'alisbir083@gmail.com';
    // $user->email_verified_at = $email_verified_at;
    $user->password = '12345678';

    $user->save();
});

//ORM Relations of Eloquent

//One to One Relationship

Route::get('/user/{id}/post', function ($id) {
    $user = User::find($id);
    $userpost = $user->post;

    // return $user;
    echo 'Hi ', $user->name, ' You have a post with the title of ', "'$userpost->post_title'", ' and the body content is ', "'$userpost->body'";
});


//Inverse One to One
Route::get('/post/{id}/user', function ($id) {

    // return PostModel::find($id)->user->name;
    $post = PostModel::find($id);
    $postowner = $post->user;
    $postownername = $postowner->name;
    // $postowneremail_address = $postowner->email_address;
    // echo $postownername, 'Email at ', $postowneremail_address;
    return ($postowner);


    echo $postowner->name;
    // return $post;

    // $postowner = $post->user->name;

    // return $postowner;

    // $user = $post->user;

    // return $user;

    // $userofthepost = $user->name;

    // echo $userofthepost;

});


//ONE TO MANY Relationships

Route::get('/userposts', function () {
    $user = User::find(2);
    $userposts = $user->posts;

    // return $userposts;
    // $userpoststitles = $userposts->post_title;



    // $userpost = $user->post;

    // echo $userpost->post_title;

    foreach ($userposts as $userpost) {
        echo  'Post Id = ', $userpost->id, ' and title = ', $userpost->post_title, '<br>';
    }
});


// Route::get('/postuser', function() {
//     $post = PostModel::find(1);

//     $postofuser = $post->user;
//     // return $postofuser;

//     echo $postofuser->name;
// });

Route::get('/create_editor_role', function () {
    $role = new Role;

    $role->name = 'Subscriber';
    $role->save();
});

// Route::get('/create_role_user_id', function () {
//     DB::insert('INSERT INTO  role_user(role_id, user_id) values(?, ?)', [1, 1]);
// });


//Many to Many Relationship
Route::get('/user/{id}/role', function ($id) {
    $user = User::find($id);

    // return $user->name;

    $userroles = $user->roles;

    //     echo  count($userroles);

    foreach ($userroles as $userrole) {
        echo $userrole->name;
    }
});


Route::get('/add_admin_user_with_post', function () {

    //Saving the User in the Users Table
    $user = new User;

    $user->name = "Admin Sabir";
    $user->email = "samin@ispportcoimputer.org";
    $user->password = "966868556898";
    $user->country_id = 3;



    $user->save();

    //Saving the User with the Role Admin

    $role = new UserRole;

    // $t = time();

    // $created_at = date('y-m-d-h-m-s', $t);
    // $updated_at = date('y-m-d-h-m-s', $t);

    $role_user_id = $user->id;

    $role_id_of_user = 1;

    $role->role_id = $role_id_of_user;

    $role->user_id = $role_user_id;
    // $role->created_at = $created_at;
    // $role->updated_at = $updated_at;

    $role->save();



    // DB::insert('INSERT INTO role_user(role_id, user_id, created_at, updated_at), values(?, ?, ?, ?)', [$role_id_of_user, $role_user_id, $created_at, $updated_at]);


    $role->save();
});

Route::get('/create_admin_posts', function () {

    $post = new PostModel;

    // $post->user_id = 1;

    $post->post_title = "Hi This is the Admin Post 4";

    $post->body = "This is the body";

    $post->save();
});




Route::get('/admin_posts', function () {
    $admin = User::find(18);

    $adminroles = $admin->roles;

    foreach ($adminroles as $adminrole) {
        $adminrolename = $adminrole->name;
    }



    $adminname = $admin->name;
    $adminposts = $admin->posts;
    $numberofpost = count($adminposts);

    echo "Hi <b>", $adminname, "</b>You are the <b>", $adminrolename, "</b> and you have <b>", $numberofpost, "</b> posts";



    // foreach ($adminposts as $adminpost){
    //     echo $adminpost;
    // }
});

//Accessing the Intermediate or Pivot Table

Route::get('/user_pivot', function () {
    $user = User::find(18);

    foreach ($user->roles as $role) {
        echo $role->pivot->created_at;
    }
});

//Accessing the Owner of a Post with Many to Many Relationship
//Inverse Many to Many Relation
Route::get('/find_owner_of_the_post', function () {
    $post = PostModel::find(8);
    // return $post;
    $postowners = $post->user;
    //To get the name of the Owner
    $postownername = $postowners->name;
    // $postownersid = $postowners->id;
    // echo $postownersid;

    // To get the Role of the Owner

    $postownerroles = $postowners->roles;
    // return $postownerroles;

    foreach ($postownerroles as $postownerrole) {
        // echo $postownerrole->name;
    }

    echo 'Hi <b>', $postownername, '</b>!! You are the <b>', $postownerrole->name, '</b> of this post whose id is <b>', $post->id;

    // $ownerrole = $post->userroles;
    // return $ownerrole;

    // foreach($postowners as $postowner){
    //    echo $postowner->name;
    // }
});


//Add Countries to the Country Table

Route::get('/add_countries', function () {
    $country = new Country;
    $country->name = "USA";
    $country->save();
});

//Has Many Through Relationship

//access the user's country

Route::get('/country_of_user', function () {
    $country = Country::find(1);
    // return $country;

    // if ($country->name === "IN") {
    //     $country->name = "India";
    // }
    echo 'Hi you are from ', $country->name, '<br>';
    // $userofthecountry = $country->posts;

    // return $userofthecountry;

    foreach ($country->posts as $post) {
        echo $post->post_title, '<br>';
    }
});


// Polymorphic Relations
Route::get('/user_photos', function () {
    // $user = User::find(2);
    // foreach ($user->photos as $photo) {
    //     echo $photo;
    // }

    $post = PostModel::find(2);




    foreach ($post->photos as $photo) {
        echo $photo->photo_path;
    }
});

Route::get('photo/{id}/user', function ($id) {
    $photo = Photo::findOrFail($id);
    $imageble = $photo->imageable;
    return $imageble;
});

Route::get('/polymorphic/{id}', function ($id) {
    $user = User::findOrFail($id);

    echo $user->name;
});

Route::get('/insert_video', function () {
    $video = new Video;

    $video->name = 'RimaeMatal.mp4';

    $video->save();
});

Route::get('/insert_tag', function () {
    $tag = new Tag;

    $tag->name = 'drunken';

    $tag->save();
});

Route::get('/insert_tagables', function () {
    $tagable = new Tagable;

    $tagable->tag_id = '1';
    $tagable->tagable_id = '2';
    $tagable->tagable_type = 'App\Models\PostModel';

    $tagable->save();
});

//Polymorphic Many to Many

Route::get('/find_post_tag', function () {
    $post = PostModel::find(2);

    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
});

//Find Owner Using the Tag or the Owner of the PolyMorphic Relation
Route::get('/find_owner_using_tag', function () {
    $tag = Tag::find(2);

    // return $tag;
    // return $tag->posts;

    foreach($tag->posts as $post){
        echo $post->post_title.'<br>';
    }
});
