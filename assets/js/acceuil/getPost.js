function getPost(){
    fetch("api/posts/getPost.php", {
    headers:{
        "Content-Type": "application/json"
    },
    method:"GET"
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
}
getPost();
