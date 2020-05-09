import axios from "axios";

const $http = axios;

$http.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
$http.defaults.headers.common["Access-Control-Allow-Credentials"] = "true";
$http.defaults.headers.common["Content-Type"] = "application/json; charset=utf-8";
$http.defaults.headers.common["Accept"] = "application/json";

export default $http;
