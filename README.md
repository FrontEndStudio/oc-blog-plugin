# October CMS Blog (extension) plugin

## About

This is a Blog (extension) plugin for [October CMS](https://octobercms.com).
Implementation is based on the [Extending the User plugin](https://vimeo.com/108040919) screencast.
Read more about the [Blog Plugin](https://octobercms.com/plugin/rainlab-blog)

## Extension implementations

### Option 1: Extending by relationship

- Custom fields are added to a new table called 'fes_blog_posts'

### Option 2: Extending direct structure

- Custom fields are added to the existing table 'rainlab_blog_posts'

## How to use 

- Under plugins create a directory named 'fes'
- Either clone 'extending-by-relationship/blog' or 'extending-direct-structure/blog' to 'plugins/fes/blog' 
- Update the new or adjusted table like: ~ php artisan plugin:refresh Fes:Blog


