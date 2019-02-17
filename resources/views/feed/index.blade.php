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
                                  <h5><a href="">@{{ post.user.name }}</a></h5>
                              </div>
                          </div>
                        </div>
                        <div class="card-body">
                            @{{post.text}}
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
                    text: ""
                },
                posts: []
            },
            methods: {
                submit() {
                    axios.post('/posts', this.post).then(response => {

                        if (response.data.success) {
                            alert("Post created successfully");
                            this.posts.push(response.data.post);
                            this.posts.this.getPosts();
                        }


                    }).catch(error => {
                        alert(error.response.data.message);
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