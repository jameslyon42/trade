<template>
	<div class='search-container'
		 ref="input"
		 v-bind:value="value"
	>
		<input 
			type="text" 
			name='search_text' 
			placeholder="Search for shit here..."
			v-model="searchText"
			v-on:input="search"
			v-on:keyup.down.up="highlight($event)"
			v-on:keyup.enter="selectHighlighted"
			v-on:focus="selectAllText($event.target)"
		>
		<div class="search-results"
			 v-if='securities'
		>
			<div class="search-result"
				 v-for="(security, index) in securities"
				 v-html='highlightSearch(security.symbol + " - " + security.name, searchText)'
				 v-on:click="select(security)"
				 v-bind:class="[security.highlighted ? 'highlighted' : '']"
			>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data: function () {
			return {
				searchText: '',
				securities: false,
				currentHighlightedIndex: false
			}
		},
		props: [
            'value'
        ],
		methods: {
			search: function () {
			    let self = this;
                axios.get('/security/search', {
                    params: {
                        search_text: this.searchText
                    }
                })
				.then(function (response) {
                    self.currentHighlightedIndex = false;
					self.securities = response.data;
				});
            },
            highlightSearch: function (value, searchText) {
                if (!value) return '';
                const regexp = new RegExp(searchText, "gi");
                value = value.replace(regexp, function (x) {
                    return '<b>' + x + '</b>';
                });
                return value
            },
			select: function (security) {
				this.searchText = security.symbol + ' - ' + security.name;
				this.securities = false;
			    this.$refs.input.value = security.id;
			    this.$emit('input', security.id);
			},
			selectHighlighted: function () {
			  if (this.currentHighlightedIndex !== false) {
			      this.select(this.securities[this.currentHighlightedIndex]);
			  }
			},
            highlight: function (event) {
			    const change = (event.key === 'ArrowUp') ? -1 : 1;

			    if (!this.securities) {
			        return;
				}
			    if (this.currentHighlightedIndex === false) {
			        if (change === 1) {
                        this.currentHighlightedIndex = 0;
                    }
				} else {
			        this.$set(this.securities[this.currentHighlightedIndex], 'highlighted', false);

                    if (this.securities[this.currentHighlightedIndex + change]) {
                        this.currentHighlightedIndex += change;
                    }
                }

                this.$set(this.securities[this.currentHighlightedIndex], 'highlighted', true);
			},
			selectAllText: function (elm) {
                elm.setSelectionRange(0, elm.value.length)
            }

		}
	}
</script>