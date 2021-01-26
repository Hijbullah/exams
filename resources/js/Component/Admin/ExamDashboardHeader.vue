<template>
    <div class="sm:flex sm:justify-between sm:items-center py-2 border-b-2 border-gray-900">
        <h2 class="text-xl text-gray-900 font-semibold ">{{ examName }}</h2>
        <div class="flex items-center space-x-2">
            <jet-nav-link :href="route('admin.exams.show', examId)" :active="route().current('admin.exams.show')">
                Dashboard
            </jet-nav-link>

            <jet-nav-link :href="route('admin.questions.index', examId)" :active="route().current('admin.questions.index')">
                Questions
            </jet-nav-link>

            <jet-nav-link :href="route('admin.exams.show', examId)" :active="route().current('admin.exams.show')">
                Results
            </jet-nav-link>

            <div class="invisible">space</div>

            <edit-button :href="route('admin.exams.edit', examId)" />
            <delete-button :href="route('admin.exams.destroy', examId)" />
            <back-button :href="route('admin.exams.index')" />
        </div>
    </div>
</template>

<script>
    import EditButton from '@/Component/Admin/ActionButton/Edit'
    import DeleteButton from '@/Component/Admin/ActionButton/Delete'
    import BackButton from '@/Component/Admin/ActionButton/Back'
    import JetNavLink from '@/Jetstream/NavLink'

    export default {
        props: {
            examName: String,
            examId: Number
        },
        components: {
            EditButton,
            DeleteButton,
            BackButton,
            JetNavLink
        },
    }
</script>
