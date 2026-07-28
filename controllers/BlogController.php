<?php

namespace Controllers;

class BlogController {
    public function index() {
        view('blog/index', [], 'layout/MainLayout');
    }

    public function blogEntry(){
        view('blog/blogEntry', [], 'layout/MainLayout');
    }
}