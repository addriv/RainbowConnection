import Route from '@ember/routing/route';
import Ember from 'ember';

export default Route.extend({
  model(){
    return Ember.$.getJSON('http://localhost:8000/api/users').then(users => {
      return users;
    })
  }
});