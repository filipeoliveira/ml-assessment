const API_URL = process.env.API_URL

export interface Subscriber {
  email: string;
  firstName: string;
  lastName: string;
  status: string;
}

export interface Pagination {
  page: number;
  limit: number;
}

/**
 * Fetch a single subscriber by email.
 *
 * @param {string} email - The email of the subscriber.
 * @returns {Promise<Subscriber>} The subscriber data.
 */
export async function getSubscriber(email: string): Promise<Subscriber> {
  const response = await fetch(`${API_URL}/subscribers/${email}`)

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`)
  }

  return await response.json()
}

/**
 * Create a new subscriber.
 *
 * @param {Subscriber} subscriber - The data of the new subscriber.
 * @returns {Promise<Subscriber>} The created subscriber data.
 */
export async function createSubscriber(subscriber: Subscriber): Promise<Subscriber> {
  const response = await fetch(`${API_URL}/subscribers`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(subscriber)
  })

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`)
  }

  return await response.json()
}

/**
 * Fetch all subscribers with pagination.
 *
 * @param {Pagination} pagination - The pagination data.
 * @returns {Promise<Subscriber[]>} The list of subscribers.
 */
export async function getAllSubscribers(pagination: Pagination): Promise<Subscriber[]> {
  const response = await fetch(`${API_URL}/subscribers?page=${pagination.page}&limit=${pagination.limit}`)

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`)
  }

  return await response.json()
}