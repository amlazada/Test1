<?php

namespace Test1\Http\Controllers;

use Illuminate\Http\Request;

use Test1\Http\Requests;

class TagController extends Controller
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->em->getRepository("Test1\Entities\Tag")->findAll();

        $result = array();

        foreach ($tags as $tag) {
            $result[] = $tag->getName();
        }

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputName = $request->input('name');

        $tag = $this->em->getRepository("Test1\Entities\Tag")->findOneBy(array('name' => $inputName));

        if (empty($tag)) {
            $tag = new \Test1\Entities\Tag($inputName);
        } else {
            return response('already exists', 422);
        }

        $this->em->persist($tag);
        $this->em->flush();

        return response(null, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = $this->em->find(\Test1\Entities\Tag::class, $id);

        if (empty($tag)) {
            return response(null, 404);
        }

        return response()->json([ 'name' => $tag->getName() ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputName = $request->input('name');
        $inputPosts = $request->input('posts');

        $tag = $this->em->find(\Test1\Entities\Tag::class, $id);

        if (empty($tag)) {
            return response(null, 404);
        }

        $tag->setName($inputName);
        try {
            $posts = $this->getPosts($inputPosts)
        } catch (\Exception $e) {
            return response($e, 422);
        }
        $tag->setPosts();

        $this->em->persist($tag);
        $this->em->flush();

        return response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->em->find(\Test1\Entities\Tag::class, $id);

        if (empty($tag)) {
            return response(null, 404);
        }

        $this->em->remove($tag);
        $this->em->flush();

        return response(null, 200);
    }

    private function getPosts($inputPostsIds)
    {
        $posts = array();
        foreach ($inputPostsIds as $inputPostId) {
            $post = $this->em->find(\Test1\Entities\Post::class, $inputPostId);
            if (empty($post)) {
                throw new \Exception('Post with id: ' . $inputPostId . 'does not exist');
                
            }
            $posts[] = $post;
        }
        return $posts;
    }
}
