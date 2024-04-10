<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $posts = $this->post->getAllPosts();
        return response()->json(['posts' => $posts]);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="The title of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="The description of the post",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="The user_id of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id
        ];
        $this->post->createPost($data);

        return response()->json(['message' => 'Post created successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a specific user",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id)
    {
        $post = $this->post->getPostById($id);
        $data = [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'created_by' => $post->user->name,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at
        ];
        return response()->json(['post' => $data]);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update a specific user",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="The title of the post",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="The description of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="The user_id of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id
        ];

        $this->post->updatePost($data, $id);
        return response()->json(['message' => 'Post updated successfully']);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a specific user",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id)
    {
        $this->post->deletePost($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
