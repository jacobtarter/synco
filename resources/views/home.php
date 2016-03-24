<!DOCTYPE html>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body>

<div ng-app="myApp" ng-controller="syncoCtrl">

<p style="font-size: 24px"><b>Synco!</b></p>  


<!test comment, testing github>


<table border='1'>
	<tr>
		<td>Title</td>
		<td>Post Text</td>
		<td>Comments</td>
		<td>Upvotes</td>
		<td>Downvotes</td>
		<td>Score</td>
	</tr>
		
	<tr ng-repeat="x in posts | limitTo:howMany">
	    <td>{{ x.about.title }}</td>
	    <td>{{ x.about.posttext }}
	    <td>{{ x.about.num_comments }}
	    <td>{{ x.about.upvotes }}</td>
	    <td>{{ x.about.downvotes }}</td>
	    <td>{{ x.about.post_score }}</td>
	</tr>
</table

</div>

<script>
	var app = angular.module('myApp', []);
	app.controller('syncoCtrl', function($scope, $http) 
	{
	 	$http.get("http://www.synco.xyz/v1/posts")
	  	.then(function (response) 
	  	{
	 		$scope.posts = response.data;
	 	
	    });		    
});
</script>

</body>
</html>

