class ListStudent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            list : props.data,
            name : "",
            age : "",
            email : ""
        }
        this.handleSubmit = this.handleSubmit.bind(this);
        this.setName = this.setName.bind(this);
        this.setAge = this.setAge.bind(this);
        this.setEmail = this.setEmail.bind(this);
    }
   
    handleSubmit(event) {

      console.log(`
        Name: ${this.state.name}
        Age: ${this.state.age}
        Email: ${this.state.email}
      `);
      
      let user = {
        id : null,
        name : this.state.name,
        age : this.state.age,
        email : this.state.email,
        username : null,
        password : null,
        role : null
      }
      console.log(user);
      let newList = this.state.list;
      newList.push(user);

      console.log(newList);
      this.setState({
        list : newList
      })
      console.log(this.state.list);
      event.preventDefault();
    }
    
     shouldComponentUpdate(nextProps, nextState){
       console.log(this.state.name, nextState.name, (this.state.name != nextState.name))
       if (this.state.name != nextState.name) return true;
       return this.state.list!==nextState.list;
     }

    setName(event) {
      this.setState({
        name : event.target.value
      })
    }

    setAge(event) {
      this.setState({
        age : event.target.value
      })
    }

    setEmail(event) {
      this.setState({
        email : event.target.value
      })
    }

    render() {
      return (
        <div>
           <form onSubmit={this.handleSubmit}>
              <h1>Add Student</h1>

              <label>
                Name:
                <input
                  type="text"
                  name="name"
                  value={this.state.name}
                  onChange={this.setName}
                />
              </label>

              <label>
                Age:
                <input
                  type="text"
                  name="age"
                  value={this.state.age}
                  onChange={this.setAge}
                  />
              </label>

              <label>
                Email:
                <input
                  name="email"
                  type="text"
                  value={this.state.email}
                  onChange={this.setEmail}
                  />
              </label>
              <button>Submit</button>
            </form>
          <table class="table table-bordered">
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Age</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
            </tr>
          {this.state.list.map(info => {
            return <tr>
              <td>{info.name}</td>
              <td>{info.age}</td>
              <td>{info.email}</td>
              <td>
                <input class="btn btn-primary edit_btn" type="button" id={info.id} name="edit" value="Edit" />
                <input class="btn btn-success add_student_into_class_btn" type="button" id={info.id} name="add_student_into_class" value="Add Class" />
                <input class="btn btn-info get_all_class_btn" type="button" id={info.id} name="get_all_class" value="Get All Class" />
                <input class="btn btn-primary add_exam_into_student_btn" type="button" id={info.id} name="add_exam_into_student" value="Add Exam" />
                <input class="btn btn-danger delete_btn" type="button" id={info.id} name="deleteBy" value="Delete" />
                </td>
            </tr>
          })}
          </table>
        </div>
      );
    }
  }
  