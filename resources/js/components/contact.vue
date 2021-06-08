<template>
<div>
     <h1>Contacts</h1>
   <form action="#" @submit.prevent="edit ? updatecontact(contact.id): createcontact()">
       <div class="form-group">
           <label for="name">Name</label>
           <input v-model="contact.name" type="text" name="name" class="form-control">
       </div>
       <div class="form-group">
           <label for="email">Email</label>
           <input v-model="contact.email" type="text" name="email" class="form-control">
       </div>
       <div class="form-group">
           <label for="phone">Phone Number</label>
           <input v-model="contact.phone" type="text" name="phone" class="form-control">
       </div>
       <div class="form-group">
           <button type="submit" v-show="!edit" class="btn btn-primary">New Contact</button>
            <button type="submit" v-show="edit" class="btn btn-secondary">Update Contact</button>

       </div>

   </form>
<h1>Contacts</h1>
<ul class="list-group">
      <li class="list-group-item list-group-item-primary" v-for="contact in list" :key="contact.id">
      <strong>{{contact.name}}</strong> {{contact.email}} {{contact.phone}}
      <span class="float-right button-group">
       <button @click="showcontact(contact.id)" class="btn btn-secondary">Edit</button>
        <button @click="deletecontact(contact.id)" class="btn btn-danger">Delete</button>
    </span>
      
    </li>
</ul>

</div>
   
</template>

<script>
export default {
    data:function(){
          return {
              edit:false,
              list:[],
              contact:{
                  id:'',
                  name:'',
                  email:'',
                  phone:''
              }
          }
    },
    mounted:function () {
       this.fetchcontactlist();
    },
    methods:{
        fetchcontactlist:function(){
             axios.get('api/contacts').then((response)=>{
                 console.log(response.data);
                 this.list=response.data;

             }).catch((error)=>{
                 console.log(error);
             });
        },
        createcontact:function(){
          console.log('Creating contact...');
          let self=this;
          let params=Object.assign({},self.contact);
          axios.post('api/contact/store',params).then(function(){
              self.contact.name='';
              self.contact.email='';
              self.contact.phone='';
              self.edit=false;
              self.fetchcontactlist();

          }).catch(function(error){
              console.log(error);
          });
        },
        showcontact:function(id){
            let self=this;
            axios.get('api/contact/'+id).then(function(response){

              self.contact.id=response.data.id;
              self.contact.name=response.data.name;
              self.contact.email=response.data.email;
              self.contact.phone=response.data.phone;
              
            }).catch(function(error){
              console.log(error);
          });
            self.edit=true;
        },
        updatecontact:function(id){
           console.log('Updating contact...'+id);
           let self=this;
          let params=Object.assign({},self.contact);
          axios.patch('api/contact/'+id,params).then(function(){
              self.contact.name='';
              self.contact.email='';
              self.contact.phone='';
              self.fetchcontactlist();
              self.edit=flase;
              

          }).catch(function(error){
              console.log(error);
          });
        },
        deletecontact:function(id){
            let self=this;
           console.log('deleteing contact...'+id);
          alert('Are sure want to delete..');
          axios.delete('api/contact/'+id).then(function(){
              self.fetchcontactlist();

          }).catch(function(error){
              console.log(error);
          });
        }
    }
}
</script>