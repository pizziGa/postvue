<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-2xl">Create a post</h1>
        <form action="/api/post" method="post" enctype="multipart/form-data" class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" name="img_path">
            <textarea class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-28 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" placeholder="Content" name="description"></textarea>
            <input type="submit" class="rounded-md border-2 cursor-pointer shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1" value="Create">
        </form>
    </div>
</template>

<script>
export default {
    name: 'CreatePostForm'
}
</script>
