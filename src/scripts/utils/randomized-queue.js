export class RandomizedQueue {
  pointer = 0
  collection = []

  constructor(items) {
    this.collection = items
    this.shuffle()
  }

  shuffle() {
    this.collection.sort(() => Math.random() - 0.5)
  }

  get next() {
    return this.collection[++this.pointer % this.collection.length]
  }
}
