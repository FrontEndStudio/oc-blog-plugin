# October CMS Blog (extension) plugin

## About

This is a Blog (extension) plugin for [October CMS](https://octobercms.com).
Implementation is based on the [Extending the User plugin](https://vimeo.com/108040919) screencast.
Read more about the [Blog Plugin](https://octobercms.com/plugin/rainlab-blog)

**There are 2 different ways of extending a plugin**  

### Option 1: Extending by relationship

- Custom fields are added to a new table called 'fes_blog_posts' see v0.5 release.

### Option 2: Extending direct structure

- Custom fields are added to the existing table 'rainlab_blog_posts'

## Extension implementations

Release v0.5 has examples of Option 1 and Option 2.  
The latest master branch has only implemented the "Extending direct structure" way for me this was the most convient way.  

## Extra functionalities

- The rainlab_blog_posts table is extended with an extra text field called: "results" 
- Prev and Next link on the blog details page 

## How to use 

- Under plugins create a directory named 'fes/blog' and checkout this repository  
- Update the new or adjusted table like: ~ php artisan plugin:refresh Fes:Blog  

