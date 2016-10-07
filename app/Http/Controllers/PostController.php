<?php

namespace Test1\Http\Controllers;

use Illuminate\Http\Request;

use Test1\Http\Requests;

class PostController extends Controller
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
    public function index(Request $request)
    {
        $countByTag = $request->query('countByTag');
        $searchByTag = $request->query('searchByTag');

        $posts = $this->em->getRepository("Test1\Entities\Post")->findAll();

        if (!empty($countByTag)) {
            $filteredPosts = $this->findPostsByTags($posts, $countByTag);

            return response()->json([ 'count' => count($filteredPosts) ]);
        }

        if (!empty($searchByTag)) {
            $posts = $this->findPostsByTags($posts, $searchByTag);
        }

        $result = array();

        foreach ($posts as $post) {
            $result[] = $post->toArray();
        }

        return response()->json($result);
    }

    private function findPostsByTags($posts, $tagsNames)
    {
        $result = array();

        $tagsNames = \Test1\Utils\ArrayUtils::Arrayify($tagsNames);

        $tags = array();

        foreach ($tagsNames as $tagName) {
            $tag = $this->em->getRepository("Test1\Entities\Tag")->findOneBy(array('name' => $tagName));
            if (empty($tag)) {
                return array();
            }
            $tags[] = $tag;
        }

        foreach ($posts as $post) {
            $postTags = $post->getTags(); 
            $containsAllInputTags = true;
            foreach ($tags as $tag) {
                if (!$postTags->contains($tag)) {
                    $containsAllInputTags = false;
                    break;
                }
            }
            if ($containsAllInputTags) {
                $result[] = $post;
            }
        }

        return $result;
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
        $inputText = $request->input('text');
        $inputTags = $request->input('tags');

        $post = new \Test1\Entities\Post($inputName, $inputText, $this->getTags($inputTags));

        $this->em->persist($post);
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
        $post = $this->em->find(\Test1\Entities\Post::class, $id);

        if (empty($post)) {
            return response(null, 404);
        }
        
        return response()->json($post->toArray());
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
        $inputText = $request->input('text');
        $inputTags = $request->input('tags');

        $post = $this->em->find(\Test1\Entities\Post::class, $id);

        if (empty($post)) {
            return response(null, 404);
        }

        $post->setName($inputName);
        $post->setText($inputText);
        $post->setTags($this->getTags($inputTags));

        $this->em->persist($post);
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
        $post = $this->em->find(\Test1\Entities\Post::class, $id);

        if (empty($post)) {
            return response(null, 404);
        }

        $this->em->remove($post);
        $this->em->flush();

        return response(null, 200);
    }

    private function getTags($inputTags)
    {
        $tags = array();
        foreach ($inputTags as $inputTag) {
            $tag = $this->em->getRepository("Test1\Entities\Tag")->findOneBy(array('name' => $inputTag));
            if (empty($tag)) {
                $tag = new \Test1\Entities\Tag($inputTag);
            }
            $tags[] = $tag;
        }
        return $tags;
    }
}
