################################################################################
# Automatically-generated file. Do not edit!
################################################################################

# Add inputs and outputs from these tool invocations to the build variables 
CPP_SRCS += \
../DBConnector.cpp \
../ImageServer.cpp \
../Main.cpp \
../MotionDetector.cpp \
../Point.cpp \
../Quadrangle.cpp 

OBJS += \
./DBConnector.o \
./ImageServer.o \
./Main.o \
./MotionDetector.o \
./Point.o \
./Quadrangle.o 

CPP_DEPS += \
./DBConnector.d \
./ImageServer.d \
./Main.d \
./MotionDetector.d \
./Point.d \
./Quadrangle.d 


# Each subdirectory must supply rules for building sources it contributes
%.o: ../%.cpp
	@echo 'Building file: $<'
	@echo 'Invoking: GCC C++ Compiler'
	g++ -O0 -g3 -Wall -c -fmessage-length=0 -MMD -MP -MF"$(@:%.o=%.d)" -MT"$(@:%.o=%.d)" -o "$@" "$<"
	@echo 'Finished building: $<'
	@echo ' '


