@extends('layouts.master')
@section('content')
    <div id="feed" class="row mt-5">

        <div class="col-md-8">
            {{--Post Editor--}}
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h3 class="m-0">Create new post</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                  <textarea v-model="post.text" placeholder="Write something..." name="" id=""
                                            cols="30" rows="2"
                                            class="form-control"></textarea>
                                </div>
                            </div>

                            <input type="file" multiple name="media[]" id="media-input">
                            <div class="row justify-content-end mt-2">
                                <div class="col-auto">
                                    <button @click="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{--Posts--}}
            <div v-for="post in posts" class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header" v-if="post.user != null">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <img :src="post.user.image" class="w-100" alt="">
                                </div>
                                <div class="col">
                                    <h5><a :href="`/profile/${post.user.id}`">@{{ post.user.name }}</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="post.type == 'image'">
                            <div class="col">
                                <img class="w-100" :src="`/${post.media}`" alt="">
                            </div>
                        </div>
                        <div class="card-body">
                            <p>
                                @{{post.text}}
                            </p>
                            <div class="row">
                                <div class="col">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="comment in post.comments">
                                            <h4>@{{ comment.user.name }}</h4>
                                            <h5> @{{ comment.text }}</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea :id="`comment-${post.id}`" @keyup.enter="submitComment(post.id)" name=""
                                              class="form-control" cols="30"
                                              rows="2" placeholder="Write a comment..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">

        </div>
    </div>

@endsection

@section("scripts")
    <script>
        let vue = new Vue({
            el: "#feed",
            data: {
                post: {
                    text: "",
                },

                posts: []
            },
            methods: {
                submit() {
                    let formData = new FormData;
                    formData.append("text", this.post.text);

                    let files = document.querySelector("#media-input").files;
                    for(i = 0; i < files.length; i++){
                        formData.append("media[]",files[i])
                    }
                    console.log(formData);


                    axios.post('/posts', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {

                        if (response.data.success) {
                            alert("Post created successfully");
                            this.posts.push(response.data.post);
                            this.getPosts();
                        }


                    }).catch(error => {

                        console.log(error);
                    });
                },
                submitComment(postId) {
                    let textarea = document.querySelector(`#comment-${postId}`);
                    axios.post(`/posts/${postId}/comments`, {text: textarea.value}).then(response => {

                    });
                },
                getPosts() {
                    axios.get("/posts").then(response => {
                        this.posts = response.data.posts;
                    });
                }
            },
            mounted() {
                this.getPosts();
            }
        })
    </script>
@endsection