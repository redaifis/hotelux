<template>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-4">Articles </h1>
        <div>
            <button class="btn btn-warning text-white rounded-0" @click.prevent="toggleNewArticle">New article</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive-md">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="article in articles" :key="article.id">
                            <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/articles/' + article.image" alt="article"></td>
                            <td>{{article.id}}</td>
                            <td>{{article.title}}</td>
                            <td><span class="badge badge-success" v-show="article.published">Published</span><span class="badge badge-secondary" v-show="!article.published">Not published</span></td>
                            <td>{{article.created_at}}</td>
                            <td><a href="#"><i class="fas fa-eye"></i></a></td>
                            <td><a href="#"><i class="fas fa-pen-alt"></i></a></td>
                            <td><a href="#"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="new-article" tabindex="-1" role="dialog">
        <div class="mmodal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="#" method="post" @submit.prevent="storeArticle">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add new article</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" v-model="article.title" name="title" id="title" class="form-control" placeholder="Article title" minlength="3" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Content</label>
                            <ckeditor v-model="article.content" required></ckeditor>
                        </div>

                        <div class="form-group">
                            <label for="price">Featured image</label>
                            <input type="file" ref="file" id="image" class="form-control-file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white rounded-0">Save changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            articles: {},
            article: {
                title: '',
                content: '',
                image: null
            },
        }
    },
    methods:{
        toggleNewArticle(){
            $('#new-article').modal('toggle')
        },
        async getArticles(){
            try {
                const articles = await axios.get(`/api/articles/all`)
                this.articles = articles.data.articles
                console.log(articles)
            } catch (error) {
                console.log(error)
            }
        },
        async storeArticle(){

            // Get image
            const file = this.$refs.file.files[0]

            if(file.type !== 'image/png' && file.type !== 'image/jpeg') return false

            let articleToStore = new FormData

            articleToStore.append('title', this.article.title)
            articleToStore.append('content', this.article.content)
            articleToStore.append('image', file)

            try {
                const article = await axios.post(`/api/articles/new`, articleToStore)
                console.log(article)
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted(){
        this.getArticles()
    }
}
</script>

<style scoped>
td {
    vertical-align: middle
}
</style>
