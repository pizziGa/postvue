<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-2xl">Edit your profile</h1>
        <form action="" method="post" enctype="multipart/form-data" class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" name="img_path">
            <input type="text" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Username" name="name">
            <textarea class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-28 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" placeholder="Content" name="biography"></textarea>
            <input type="submit" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1" value="Edit">
        </form>
    </div>
</template>

<script>
export default {
    name: 'EditProfileForm'
}
</script>