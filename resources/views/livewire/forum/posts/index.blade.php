<div>
    <x-title title="{{__('Forum Posts')}}" />

    @auth()
        <x-forum.write-a-post />
    @endauth

    <x-forum.posts-table :posts="$posts" />
</div>
