<template>
  <div class="container">
      <form>
        <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea class="form-control" id="comment" />
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
        <tr>
          <td align="left">John</td>
          <td align="left">Doe</td>
          <td align="left">john@example.com</td>
          <td align="left">john@example.com</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'hello',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
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
