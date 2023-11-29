<template>
  <form>
    <div class="mb-3">
      <label for="identifier" class="form-label">Identifier</label>
      <input class="form-control" id="identifier" aria-describedby="identifier"
             :value="contentBlockStore.package"
      >
    </div>
    <div class="mb-3">
      <label for="vendor" class="form-label">Vendor</label>
      <input class="form-control" id="vendor" aria-describedby="vendor"
             :value="contentBlockStore.vendor"
      >
    </div>
    <div class="mb-3">
      <label for="group" class="form-label">Group</label>
      Group
      <input class="form-control" id="group" aria-describedby="group">
    </div>
    <div class="mb-3">
      <label for="typename" class="form-label">Type Name</label>
      <input class="form-control" id="typename" aria-describedby="typename">
    </div>
    <div class="mb-3">
      <label for="table" class="form-label">Table</label>
      <input class="form-control" id="table" aria-describedby="table">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>

<script setup>
import {useContentBlockStore} from "@/store/contentBlockStore";
const contentBlockStore = useContentBlockStore();
</script>

<style scoped>
</style>
