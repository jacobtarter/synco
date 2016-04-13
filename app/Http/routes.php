<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('posts', 'PostController');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


//authentication routes
Route::controllers([
		'auth' => 'Auth\AuthController',                       
		'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => ['web']], function () {

	#Route::auth();

	Route::get('/', 'PagesController@getIndex');
	

	#Route::get('/home', 'HomeController@index');

});

Route::get( 'test1', function() {
	print "<br /> Hello! from Test1";
});
Route::get( 'v1/posts', function() {
	$WHERE= "
	SELECT p.PID, p.Title, p.PostText, p.UID, p.PCDate, c.CID, c.c_PID, c.CommentText, c.UID, c.CommentDate, v.VID, v.VoteScore, v.v_PID, v.UID, v.Date
	FROM posts p
	LEFT JOIN Comments c ON p.PID = c.c_PID
	LEFT JOIN Votes v ON p.PID = v.v_PID;
	
";	

	$DATA = (array)DB::select( "$WHERE");
	
	$postsFinal = array();
	$comments = array();
	$current = null;
	$previousID = null;
	$checkedPostScore=null;
	$previousComment=null;
	$previousVote=null;	
	$commentCount=0;
	$downvotes=0;
	$upvotes=0;
	$voteScore=0;

	

	foreach($DATA as $row){
		if($row->PID != $previousID)
		{
			if( !is_null($current))
			{
				$current['num_comments'] = $commentCount;
				$current['upvotes'] = $upvotes;
				$current['downvotes'] = $downvotes;
				$current['post_score'] = ($upvotes-$downvotes);
				$currentBlock['about'] = $current;
				$currentBlock['comments'] = $commentBlock;	
				$currentBlock['votes'] = $voteBlock;
				$postsFinal[] = $currentBlock;
				$current = null;
				$votes=null;
				$voteBlock = null;
				$currentBlock = null;
				$commentBlock = null;
				$previousID = null;
				$previousComment = null;
				$previousVote = null;
				$commentCount = 0;
				$upvotes=0;
				$downvotes=0;
				$comments = array();
			}
		$currentBlock = array();
		$current = array();
		$checkedPostScore = null;
		$current['pid'] = $row->PID;
		$current['title'] = $row->Title;
		$current['posttext'] = $row->PostText;
		$current['uid'] = $row->UID;
		$current['postdate'] = $row->PCDate;

		$previousID = $current['pid'];

		}

		if ($row->CID!=$previousComment)
		{
			$comments['cid'] = $row->CID;
			$comments['commenttext'] = $row->CommentText;
			$comments['uid'] = $row->UID;
			$comments['commentdate'] = $row->CommentDate;
			$commentBlock[] = $comments;
			$previousComment = $row->CID;
			$comments = null;
			$commentCount++;
		}

		if ($row->VID!=$previousVote)
		{
			$votes['vid'] = $row->VID;
			$votes['votescore'] = $row->VoteScore;
			$votes['uid'] = $row->UID;
			$votes['votedate'] = $row->Date;
			$voteBlock[]= $votes;
			$previousVote = $row->VID;
			if($row->VoteScore == 1)
			{
				$upvotes++;
			}
			if($row->VoteScore == -1)
			{
				$downvotes++;
			}
			$votes = null;	
		}

		
	}
	if (!is_null($current))
	{
		$current['num_comments'] = $commentCount;
		$current['upvotes'] = $upvotes;
		$current['downvotes'] = $downvotes;
		$current['post_score'] = ($upvotes-$downvotes);
		$currentBlock['about']=$current;
		$currentBlock['comments']=$commentBlock;
		$currentBlock['votes']=$voteBlock;
		$postsFinal[] = $currentBlock;
	}
	
	print (json_encode($postsFinal));
	//echo json_encode($DATA);
}		
);
	




