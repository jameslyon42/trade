<template>
	<div class='main-container'>
		<security-search
			v-model='security_search'
			v-on:input="selected"
		>
		</security-search>
	</div>
</template>

<script>
	import SecuritySearch from './security/Search.vue'

	export default {
	    data: function () {
	      	return {
				security_search: ''
			};
		},
		components: {
			SecuritySearch
		},
		methods: {
		    selected: function (security_id) {
                axios.get('/security/' + security_id)
				.then(function (response) {
					console.log(response.data);
				});
			}
		}
	}
</script>