<?php
/**
 * Created by PhpStorm.
 * User: taint
 * Date: 7/22/2017
 * Time: 2:55 PM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Comments extends Model
{
    const CACHE_INDENTIFIER = 'comment:';
    //cache duration = 1 day
    const CACHE_DURATION_MINUTES = 1440;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'comment'
    ];

    protected $table = 'comments';

    /**
     * get all comments
     * @return Comments collection
     */
    static public function getComments() {
        //return decoded cached object if the comments are cached
        if(Cache::has(SELF::CACHE_INDENTIFIER)) {
            $comment = json_decode(Cache::get(SELF::CACHE_INDENTIFIER));
        //else retrieve comments from database and cache comments in json format
        } else{
            $comment = SELF::all();
            Cache::put(SELF::CACHE_INDENTIFIER, json_encode($comment), SELF::CACHE_DURATION_MINUTES);
        }
        return $comment;
    }

    /**
     * get single comment by comment id
     * @param $id int
     * @return Comment
     */
    static public function getComment($id) {
        //return decoded cached object if the comment are cached
        if(Cache::has(SELF::CACHE_INDENTIFIER.$id)) {
            $comment = json_decode(Cache::get(SELF::CACHE_INDENTIFIER.$id));
        //else retrieve comment from database and cache comment in json format
        } else{
            $comment = SELF::find($id);
            Cache::put(SELF::CACHE_INDENTIFIER.$id, json_encode($comment), SELF::CACHE_DURATION_MINUTES);
        }
        return $comment;
    }

    /**
     * create comment
     * @param $commentContent string
     */
    static public function createComment($commentContent) {
        $comment = Comments::create(['comment' => $commentContent]);
        //cache encoded comment object and remove comment collection cache after new comment creation
        if($id = $comment->id) {
            Cache::put(SELF::CACHE_INDENTIFIER.$comment->id, json_encode($comment), SELF::CACHE_DURATION_MINUTES);
            Cache::forget(SELF::CACHE_INDENTIFIER);
        }
    }

    /**
     * update comment
     * @param Comments $comment
     * @param $commentContent string
     */
    static public function updateComment(Comments $comment, $commentContent) {
        $comment->comment = $commentContent;
        $comment->save();
        //update the comment cache and remove comment collection cache after comment update
        Cache::put(SELF::CACHE_INDENTIFIER.$comment->id, json_encode($comment), SELF::CACHE_DURATION_MINUTES);
        Cache::forget(SELF::CACHE_INDENTIFIER);
    }

    /**
     * delete comment
     * @param Comments $comment
     */
    static public function deleteComment(Comments $comment) {
        $comment->delete();
        //remove the comment cache and remove comment collection cache after comment delete
        Cache::forget(SELF::CACHE_INDENTIFIER.$comment->id);
        Cache::forget(SELF::CACHE_INDENTIFIER);
    }
}