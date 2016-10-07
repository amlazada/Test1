<?php

namespace Test1\Http\Controllers;

use Illuminate\Http\Request;

use Test1\Http\Requests;

use Illuminate\Support\Facades\Redis;

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
            $result[] = array('id' => $tag->getId(), 'name' => $tag->getName());
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
        $inputPosts = $request->input('posts');

        return $this->save($inputName, $inputPosts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cachedTag = Redis::hgetAll('tag:'.$id);

        if (!empty($cachedTag)) {
            return response()->json([ 'id' => $id, 'name' => $cachedTag['name'] ]);
        }

        $tag = $this->em->find(\Test1\Entities\Tag::class, $id);

        if (empty($tag)) {
            return response(null, 404);
        }

        Redis::hset('tag:'.$id, 'name', $tag->getName());

        return response()->json([ 'id' => $tag->getId(), 'name' => $tag->getName() ]);
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

        return $this->save($inputName, $inputPosts, $id);
    }

    private function save($name, $postsIds, $id = null)
    {
        if (empty($name)) {
            return response("Name of a tag should not be empty", 422);
        }

        $posts = array();

        try {
            $posts = $this->getPosts(\Test1\Utils\ArrayUtils::Arrayify($postsIds));
        } catch (\Exception $e) {
            return response("Tag cannot reference a non-existent post", 422);
        }

        if (empty($id)) {
            $tag = $this->em->getRepository("Test1\Entities\Tag")->findOneBy(array('name' => $name));

            if (empty($tag)) {
                $tag = new \Test1\Entities\Tag($name);
            } else {
                return response('Tag ' . $name . ' already exists', 422);
            }
        } else {
            $tag = $this->em->find(\Test1\Entities\Tag::class, $id);

            if (empty($tag)) {
                return response(null, 404);
            }

            $tag->setName($name);
        }

        foreach ($posts as $post) {
            $post->addTag($tag);
        }

        $tag->setPosts($posts);

        $this->em->persist($tag);
        $this->em->flush();

        return response($tag->getId(), 200);
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
