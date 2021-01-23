<template>
    <div class="leading-normal tracking-normal">
        <div class="flex flex-wrap">

            <Sidebar />

            <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen">

                <Navbar />

                <main>
                    <div class="p-6 bg-gray-100 mb-20">
                        <slot></slot>
                    </div>
                </main>

                <portal-target name="modal" multiple></portal-target>

                <Footer />

            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from '@/component/admin/Navbar'
    import Sidebar from '@/component/admin/Sidebar'
    import Footer from '@/component/admin/Footer'

    export default {
        components: {
            Navbar,
            Sidebar,
            Footer,  
        }
    }
</script>
