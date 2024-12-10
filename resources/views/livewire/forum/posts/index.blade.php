<div>
    <x-title title="Forum Posts"/>

    @auth()
        <x-forum.write-a-post/>
    @endauth

    <x-forum.posts-table :posts="$posts"/>
</div>
