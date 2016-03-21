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

```
git clone --depth 1  https://github.com/FrontEndStudio/oc-blog-plugin blog
cd blog
git filter-branch --prune-empty --subdirectory-filter extending-by-relationship/blog HEAD
```

- OR 

```
git clone --depth 1  https://github.com/FrontEndStudio/oc-blog-plugin blog
cd blog
git filter-branch --prune-empty --subdirectory-filter extending-direct-structure/blog HEAD
```

- Update the new or adjusted table like: ~ php artisan plugin:refresh Fes:Blog


