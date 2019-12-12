<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

class Topic extends Model
{


    public $timestamps=false;

    use RevisionableTrait;
    protected $keepRevisionOf=[
        'deleted_at',
        'is_excellent',
        'is_blocked',
        'order',
    ];

    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'topics.title' => 10,
            'topics.body'  => 5,
        ]
    ];


    use PresentableTrait;
    protected $presenter = 'Phphub\Presenters\TopicPresenter';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'is_draft',
        'source',
        'body_original',
        'user_id',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleted(function ($topic){
            foreach ($topic->replies as $reply){
                app(UserRepliedTopic::class)->remove($reply->user,$reply);
            }
        });
    }

    public function share_link(){
        return $this->hasOne(ShareLink::class);
    }
    public function votes(){
        return $this->morphMany(Vote::class,'votable');
    }
    public function attentedUsers(){

        return $this->belongsToMany(User::class,'attention')->get();
    }
    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function Tag(){
        return $this->hasMany(Tag::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'last_reply_user_id');
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function blogs(){
        return $this->belongsToMany(Blog::class,'blog_topics');
    }
    public function appends(){
        return $this->hasMany(Append::class);
        }
    public function getRepliesWithLimit($limit=30,$order='created_at'){

        $pageName='page';
        $latest_page=is_null(Input::get($pageName))?ceil($this->reply_count/$limit):1;
        $query=$this->replies()->with('user');

        $query=($order=='vote_count')? $query->orderBy('vote_count','desc'):$query->orderBy('created_at','asc');

        return $query->paginate($limit,['*'],$pageName,$latest_page);
    }

    public function getSameCategoryTopics(){
        $data=Cache::remember('phphub_hot_topics_'.$this->category_id,30,function(){
            return Topic::where('category_id','=',$this->category_id)
                ->recent()
                ->with('user')
                ->take(3)
                ->get();
        });
        return $data;
    }

    public static function makeException($body){
        $html=$body;
    }
}