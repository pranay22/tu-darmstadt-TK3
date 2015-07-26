import Statistic
import argparse

if __name__ == '__main__':

    parser = argparse.ArgumentParser(description='Starts the client')
#    parser.add_argument('-room_id', '--room_id', type=int, default=0,
    parser.add_argument('-room_id', '--room_id', type=str, default='None',
                        help='Sets room ID')
#    parser.add_argument('-seat_id', '--seat_id', type=int, default=0,
    parser.add_argument('-seat_id', '--seat_id', type=str, default="None",
                        help='Sets seat ID')
    args = parser.parse_args()

    Statistic.check_occupied(args.room_id, args.seat_id)
