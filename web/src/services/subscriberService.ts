const API_URL = `${process.env.VUE_APP_API_URL}/api`;

export interface PaginationMetadata {
  page: number;
  pageSize: number;
  totalSubscribers: number;
  totalPages: number;
}

export interface SubscriberPaginatedData {
  data: Subscriber[];
  metadata: PaginationMetadata;
}
export interface Subscriber {
  email: string;
  name: string;
  lastName: string;
  status: string;
}

export interface Pagination {
  page: number;
  pageSize: number;
}

/**
 * Fetch a single subscriber by email.
 *
 * @param {string} email - The email of the subscriber.
 * @returns {Promise<Subscriber>} The subscriber data.
 */
export async function getSubscriber(email: string): Promise<Subscriber> {
  const response = await fetch(`${API_URL}/subscribers/${email}`);

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }

  return await response.json();
}

/**
 * Create a new subscriber.
 *
 * @param {Subscriber} subscriber - The data of the new subscriber.
 * @returns {Promise<Subscriber>} The created subscriber data.
 */
export async function createSubscriber(
  subscriber: Subscriber
): Promise<Subscriber> {
  const response = await fetch(`${API_URL}/subscribers`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      name: subscriber.name,
      last_name: subscriber.lastName,
      email: subscriber.email,
      status: subscriber.status,
    }),
  });

  const responseData = await response.json();

  if (response.status === 201) {
    return responseData;
  }

  if (response.status === 200) {
    // subscriber already exists
    throw new Error(responseData.message);
  } else {
    throw new Error("Unexpected status code");
  }
}

/**
 * Fetch all subscribers with pagination.
 *
 * @param {Pagination} pagination - The pagination data.
 * @returns {Promise<SubscriberPaginatedData>} The getAllSubscribers response.
 */
export async function getAllSubscribers(
  pagination: Pagination
): Promise<SubscriberPaginatedData> {
  const response = await fetch(
    `${API_URL}/subscribers?page=${pagination.page}&pageSize=${pagination.pageSize}`
  );

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }

  return await response.json();
}
