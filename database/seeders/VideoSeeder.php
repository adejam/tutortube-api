<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('videos')->insert(array(
            0 => array(
                'id' => 1,
                'video_id' => 'IsXEVQRaTX8',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=IsXEVQRaTX8',
                'title' => 'HTML5 as Fast As Possible',
                'description' => 'What changes did the fifth iteration of HTML bring? Why is a new HTML revision so important?',
                'category' => 'html',
            ),
            1 => array(
                'id' => 2,
                'video_id' => 'MDLn5-zSQQI',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=MDLn5-zSQQI',
                'title' => 'Next JS Registration flow completed with Formik and Yup validation',
                'description' => 'In this video, we are going to look at the complete code for the registration of the user.',
                'category' => 'html',
            ),
            2 => array(
                'id' => 3,
                'video_id' => '3leKYvYL5aw',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=3leKYvYL5aw',
                'title' => 'Next JS Registration flow completed with Formik and Yup validation',
                'description' => 'In this video, we are going to look at the complete code for the registration of the user.',
                'category' => 'html',
            ),
            3 => array(
                'id' => 4,
                'video_id' => '88PXJAA6szs',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=88PXJAA6szs',
                'title' => 'Next JS Registration flow completed with Formik and Yup validation',
                'description' => 'In this video, we are going to look at the complete code for the registration of the user.',
                'category' => 'html',
            ),
            4 => array(
                'id' => 5,
                'video_id' => '-USAeFpVf_A',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=-USAeFpVf_A',
                'title' => 'Next JS Registration flow completed with Formik and Yup validation',
                'description' => 'In this video, we are going to look at the complete code for the registration of the user.',
                'category' => 'html',
            ),
            5 => array(
                'id' => 6,
                'video_id' => '1PnVor36_40',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=1PnVor36_40',
                'title' => 'Learn CSS in 20 Minutes',
                'description' => 'In this video we will cover everything you need to know to get up and running with CSS in only 20 minutes. We will cover CSS syntax, how to add CSS to your HTML, CSS colors, CSS units, the box model, and best practices for CSS walking through a full example of CSS being used to style an HTML page. By the end of this video you will know enough about CSS to style any basic web pages in your own projects!',
                'category' => 'css',
            ),
            6 => array(
                'id' => 7,
                'video_id' => '6vbgZnQrpbU',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=6vbgZnQrpbU',
                'title' => 'What is CSS | CSS Explained For Beginners',
                'description' => 'This Edureka video on "what is CSS" explains what is CSS along with all the varied elements and fundamentals of CSS',
                'category' => 'css',
            ),
            7 => array(
                'id' => 8,
                'video_id' => '0afZj1G0BIE',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=0afZj1G0BIE',
                'title' => 'Learn CSS in 12 minutes',
                'description' => 'I introduce CSS, explain how to link a CSS file with an HTML document and teach the syntax of the language along with the most common properties',
                'category' => 'css',
            ),
            8 => array(
                'id' => 9,
                'video_id' => 'W6NZfCO5SIk',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=W6NZfCO5SIk',
                'title' => 'JavaScript tutorial for beginners',
                'description' => 'I have designed this JavaScript tutorial for beginners to learn JavaScript from scratch. We will start off by answering the frequently asked questions by beginners about JavaScript and shortly after we will set up our development environment and start coding. Whether you are a beginner and want to learn to code, or you know any programming language and just want to learn JavaScript for web development, this tutorial helps you learn JavaScript fast. You dont need any prior experience with JavaScript or any other programming languages. Just watch this JavaScript tutorial to the end and you will be writing JavaScript code in no time. If you want to become a front-end developer, you have to learn JavaScript. It is the programming language that every front-end developer must know. You can also use JavaScript on the back-end using Node. Node is a run-time environment for executing JavaScript code outside of a browser. With Node and Express (a popular JavaScript framework), you can build back-end of web and mobile applications. If you are looking for a crash course that helps you get started with JavaScript quickly, this course is for you',
                'category' => 'javascript',
            ),
            9 => array(
                'id' => 10,
                'video_id' => 'c-I5S_zTwAc',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=c-I5S_zTwAc',
                'title' => 'Learn JavaScript in just 5 minutes',
                'description' => ' Learn the most important parts of 2020 Javascript in just 5 minutes',
                'category' => 'javascript',
            ),
            10 => array(
                'id' => 11,
                'video_id' => 'Y6aYx_KKM7A',
                'user_id' => 1,
                'url' => 'https://m.youtube.com/watch?v=Y6aYx_KKM7A',
                'title' => 'What Is ReactJS? | ReactJS Basics | Learn ReactJS | ReactJS Tutorial For Beginners | Simplilearn',
                'description' => 'In this video, we learn all about ReactJS, its features and some basic concepts required to build a React Application. React is a JavaScript library used for building fast and interactive user interfaces for the web as well as mobile applications. It is an open-source, reusable component-based front-end library used by many developers across the globe. We also look at the current industry trends of React, and the salary scenario of a React developer. To give you an overview, here are the topics we cover:',
                'category' => 'react',
            ),
            11 => array(
                'id' => 12,
                'video_id' => 'I7CfaDYzTVM',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=I7CfaDYzTVM',
                'title' => 'Bootstrap 5 - First Look',
                'description' => 'In this video we will look at Bootstrap 5 Alpha and talk about some of the changes. We will also set up a simple project',
                'category' => 'bootstrap',
            ),
            12 => array(
                'id' => 13,
                'video_id' => 'Sklc_fQBmcs',
                'user_id' => 1,
                'url' => 'https://www.youtube.com/watch?v=Sklc_fQBmcs',
                'title' => 'Next.js in 100 Seconds // Plus Full Beginners Tutorial',
                'description' => 'Learn the basics of Next.js in 100 Seconds! Then build your first server-rendered react app with a full Next.js beginners tutorial',
                'category' => 'next',
            ),
        ));
    }
}
