<template>
    <admin-layout>
        <div>
            <exam-header :examName="exam.name" :examId="exam.id" />

            <div class="mt-5">
                Question
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import ExamHeader from '@/Component/Admin/ExamDashboardHeader'
 

    export default {
        components: {
            AdminLayout,
            ExamHeader,
        },
        props: {
            exam: Object
        }
    }
</script>