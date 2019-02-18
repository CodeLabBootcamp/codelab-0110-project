@extends('layouts.master')
@section('content')

    <div class="row justify-content-center mt-5" id="profile">
        <div v-if="user != null" class="col-md-8">
            <div  v-for="post in user.posts" class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header" v-if="user != null">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <img :src="`/${user.image}`" class="w-100" alt="">
                                </div>
                                <div class="col">
                                    <h5><a :href="`/profile/${user.id}`">@{{ user.name }}</a></h5>
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
    </div>
@endsection
@section("scripts")
    <script>
        let vue = new Vue({
            el: "#profile",
            data: {
                user: null
            },
            mounted() {
                // 1- Pass id when return view
                // 2- Get the id from the url

                axios.get(`/users/3/posts/`).then(response => {
                    this.user = response.data.user;
                })
            }
        })
    </script>
@endsection