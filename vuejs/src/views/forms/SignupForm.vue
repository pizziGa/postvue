<template>
    <div class="flex flex-col items-center h-[40rem] font-semibold justify-center">
        <h1 class="text-3xl">Registration</h1>
        <form action="api/store" method="POST" enctype="multipart/form-data" class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Username" name="name">
            <input type="text" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Email" name="email">
            <input type="password" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Password" name="password">
            <input type="date" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" name="birthdate">
            <input type="file" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-10 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" name="pfp_path">
            <input type="submit" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 hover:cursor-pointer w-32 text-base p-1" value="Signup">
        </form>
        <router-link to="/login" class="flex text-sm align-middle">Do you already have an account? Log in</router-link>
    </div>
</template>

<script>
export default {
    name: 'SignupForm'
}
</script>
