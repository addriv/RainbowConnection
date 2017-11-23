import Route from '@ember/routing/route';
import Ember from 'ember';

export default Route.extend({
  model(params) {
    return Ember.$.getJSON(`http://localhost:8000/api/users/${params.userId}`).then(user => {
      return user.data.attributes;
    });
  }
});
