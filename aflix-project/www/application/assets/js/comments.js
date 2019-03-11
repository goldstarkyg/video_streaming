Vue.component('comments',{

  template : '#comments',

  data: function(){
    return {
      edit:false,
      comments:[],
      comment: {
        title:'',
        body: '',
        id: '',
      },
    }
  },


created: function(){
  alert('das');
  this.fetchComments();
},
ready: function(){
  alert('dsa');
  this.fetchComments();
},

methods: {
  fetchComments: function(){
    this.$http.get("../api/post/"+window.Laravel.post_id+"/comments")
      .then(function (response){
        this.comments = response.data;
    });
  },

  createComment: function(){
    this.$http.post("../api/post/"+window.Laravel.post_id+"/comment", this.comment)
      .then( function (response){
        this.comment.body= '';
        this.fetchComments();
    });
  },

  editComment: function(comment_id){
    this.$http.patch("../api/post/"+window.Laravel.post_id+"/comment/"+comment_id, this.comment)
      .then( function (response){
        this.comment.body= '';
        this.comment.id= '';
        this.fetchComments();
        this.edit = false;
    });
  },

  deleteComment: function(comment_id){
    this.$http.delete("../api/post/"+window.Laravel.post_id+"/comment/"+comment_id)
      .then( function (response){
        this.comment.body= '';
        this.fetchComments();
    });
  },

  showComment: function(comment_id){
    for (var i = 0; i < this.comments.length; i++) {
      if (this.comments[i].id == comment_id) {
        this.comment.body = this.comments[i].body;
        this.comment.id = this.comments[i].id;
        this.edit = true;
      }
    }
  }
}
});

app = new Vue({
    el: '#app'

});
