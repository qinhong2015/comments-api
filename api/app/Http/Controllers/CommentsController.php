<?php
/**
 * Created by PhpStorm.
 * User: taint
 * Date: 7/22/2017
 * Time: 12:58 PM
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cache;
use App\Model\Comments;

class CommentsController extends Controller
{
    /**
     * Comment GET controller Method
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id) {
        try {
            $comment = Comments::getComment($id);
            if(!$comment)
                return response()->json("Requested comment id:$id not found!", 404);
        } catch  (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json(['data' => $comment], 200);
    }
    /**
     * Comments GET controller Method
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() {
        try {
            $comments = Comments::getComments();
        } catch  (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json(['data' => $comments], 200);
    }
    /**
     * Comment PUT controller Method
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request) {
        try {
            $commentContent = trim($request->input('comment'));
            if(empty($commentContent))
                return response()->json("Empty comment!", 400);
            $comment = Comments::find($id);
            if(!$comment)
                return response()->json("Requested comment id:$id not found!", 404);
            Comments::updateComment($comment, $commentContent);
        } catch  (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        return response()->json(['{}'], 200);
    }
    /**
     * Comment POST controller Method
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        try {
            $commentContent = trim($request->input('comment'));
            if(empty($commentContent))
                return response()->json("Empty comment!", 400);
            Comments::createComment($commentContent);
        } catch  (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json('{}', 200);
    }

    /**
     * Comment DELETE controller Method
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        try {
            $comment = Comments::find($id);
            if(!$comment)
                return response()->json("Requested comment id:$id not found!", 404);
            Comments::deleteComment($comment);
        } catch  (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['{}'], 200);
    }
}