// import external dependencies
// import 'jquery';
import 'cnphtml/dist/main.js';
import 'typeahead.js/dist/typeahead.bundle.js'
import Bloodhound from 'typeahead.js/dist/bloodhound.js'
// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());

var data = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '/wp-json/wp/v1/all-posts',
});

jQuery('.typeahead').typeahead( null, { name: 'fuck', source: data } );
