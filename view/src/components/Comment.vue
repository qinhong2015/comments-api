<template>
  <div class="container">
      <form v-on:submit.prevent="onSubmit">
        <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea v-model="message" class="form-control" name="comment" id="comment" />
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Comment</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="comment in comments">
          <td align="left">{{comment.id}}</td>
          <td align="left"><textarea v-model="comment.comment" class="form-control" name="comment" id="comment" /></td>
          <td align="left"><button type="button" class="btn btn-primary" v-on:click="update(comment)">Update</button></td>
          <td align="left"><button type="button" class="btn btn-primary" v-on:click="remove(comment)">Delete</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'comment',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      comments: [],
      message: ''
    }
  },
  methods: {
    onSubmit: function (e) {
      this.createComment(this.message)
    },
    remove: function (comment) {
      this.deleteComment(comment.id)
    },
    update: function (comment) {
      this.updateComment(comment.id, comment.comment)
    },
    getComments: function () {
      this.$http.get('comments').then(response => {
        response.json().then(comments => [
          (this.comments = comments.data)
        ])
      }, response => this.errorResponse(response))
    },
    createComment: function (message) {
      this.$http.post('comments', {'comment': message}).then(response => {
        this.message = ''
        this.getComments()
      }, response => this.errorResponse(response))
    },
    deleteComment: function (id) {
      this.$http.delete('comments/' + id).then(response => {
        this.getComments()
      }, response => this.errorResponse(response))
    },
    updateComment: function (id, message) {
      this.$http.put('comments/' + id, {'comment': message}).then(response => {
        this.getComments()
      }, response => this.errorResponse(response))
    },
    errorResponse: function (response) {
      console.log(response)
      alert(response.statusText + response.bodyText)
    }
  },
  mounted: function () {
    this.getComments()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>
