<?php

$app->get("/api/hello", function ($request, $response, $args)  {
	return $response->jsonOk("Hello");
});
