<template>
  <div>
    <Navbar />
      <h2>Articles</h2>
      <form @submit.prevent="addArticle"  class="mb-3">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Title" v-model="article.title">                 
        </div>
        <div class="form-group">
          <textarea class="form-control" placeholder="Body" v-model="article.body">
          </textarea>
        </div>
        <button class="btn btn-light btn-block" type="submit">Save</button>
      </form>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item" :class="[{disabled: !pagination.prev_page_url}]">
            <a class="page-link" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link text-dark" >Page {{pagination.current_page}}/{{pagination.last_page}}</a>
          </li>
          <li class="page-item" :class="[{disabled: !pagination.next_page_url}]">
            <a class="page-link" @click="fetchArticles(pagination.next_page_url)">Next</a>
          </li>
        </ul>
      </nav>
      <div class="m-2 card card-body" v-for="(article) in articles" :key="article.id"> 
        <h3>{{article.title}}</h3>
        <p>{{article.body}}</p>
        <hr>
        <button @click="editArticle(article)" class="btn btn-warning mb-2">Edit</button>
        <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>

      </div>
  </div>
</template>

<script>
import Navbar from './Navbar'

export default {
    name: "Articles",
    components: {
      Navbar
    },
    data() {
      return {
        articles: [],
        article: {
          id: null,
          title: null,
          body: null
        },
        article_id: null,
        pagination: {},
        edit: false
      }
    },
    methods: {
      fetchArticles(page_url){
        let vm = this;
        page_url = page_url || 'api/articles';
        fetch(page_url)
        .then( res => res.json())
        .then( res => {
          this.articles = res.data;
          vm.makePagination(res.meta,res.links);
        })
        .catch(err => console.log(err));
      },
      makePagination(meta,links){
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev
        };
        this.pagination = pagination;
      },
      deleteArticle(id){
        if(confirm('Are you sure?')){
          fetch(`api/article/${id}`, {
            method: 'delete'
          })
          .then( res => res.json())
          .then( data => {
            alert('Article Removed');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
        }
      },
      addArticle(){
        if(this.edit === false){
          //Add
          fetch('api/article',{
            method: 'post',
            body: JSON.stringify(this.article),
            headers: {
              'content-type':'application/json'
            }
          })
          .then(res => res.json())
          .then( data => {
            this.article.title = null;
            this.article.body = null;
            alert('Article Added'); 
            this.fetchArticles();
          })
          .catch(err => console.log(err));
        }
        else{
          //update
          fetch('api/article',{
            method: 'put',
            body: JSON.stringify(this.article),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(res => res.json())
          .then( data => {
            this.article.title = null;
            this.article.body = null;
            alert('Article Updated'); 
            this.fetchArticles();
          })
          .catch(err => console.log(err));
        }
      },
      editArticle(article){
        this.edit = true;
        this.article.id = article.id;
        this.article.article_id = article.id;
        this.article.title = article.title;
        this.article.body = article.body
      }
    },
    created(){
      this.fetchArticles();
    }

}
</script>

<style scoped>
a:hover{
  cursor: pointer;
}

</style>